import Controller from '@ember/controller';
import { action } from '@ember/object';
import { tracked } from '@glimmer/tracking';
export default class CandidatesController extends Controller {
  @tracked isModalOpen = false;

  @action
  toggleModal() {
    this.isModalOpen = !this.isModalOpen;
  }

  @action
  saveCandidate(candidate) {
    candidate
      .save()
      .then((payload) => {
        //handle success
      })
      .catch((e) => {
        // handle failure
      });
  }
}
