<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

$loader = new Loader();
$loader->registerNamespaces(
    [
        'App\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();


$container = new FactoryDefault();
$container->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'db',
                'username' => 'dev',
                'password' => 'plokijuh',
                'dbname'   => 'hiring',
            ]
        );
    }
);

$app = new Micro($container);

$app->get(
    '/',
    function () {
      header('Content-type: application/json');
      echo json_encode([
        'available REST endpoints:',
        'GET /api/applicants',
        'GET /api/applicants/{id}',
        'POST /api/applicants',
      ]);
    }
);

$app->get(
  '/api/applicants',
  function () use ($app) {
    $phql = "SELECT id, name, age FROM App\Models\Candidates ORDER BY age";
    $candidates = $app
      ->modelsManager
      ->executeQuery($phql)
    ;

    $data = [];

    foreach ($candidates as $cand) {
      $data[] = [
        'type' => 'applicant',
        'id'   => $cand->id,
        'attributes' => [
        'name' => $cand->name,
        'age' => $cand->age,
      ]
      ];
    }

    header('Content-type: application/vnd.api+json'); // JSON API
    echo json_encode(['data' => $data]);
  }
);

$app->post(
  '/api/applicants',
  function () use ($app) {
    $applicant = $app->request->getJsonRawBody();
    $applicant = $applicant->data->attributes;

    $name = $applicant->name;
    $age = $applicant->age;

    $phql = "INSERT INTO App\Models\Candidates (name,age) VALUES ('$name', '$age')";

    $status = $app
      ->modelsManager
      ->executeQuery($phql);

    // Check if the insertion was successful
    if ($status->success() === true) {
        $data = [
          'type' => 'applicant',
          'id'   => $applicant->id,
          'attributes' => [
            'name' => $applicant->name,
            'age' => $applicant->age,
          ]
          ];
        header('Content-type: application/vnd.api+json'); // JSON API
        echo json_encode(['data' => $data]);
    }
  }
);

$app->handle($_SERVER['REQUEST_URI']);
