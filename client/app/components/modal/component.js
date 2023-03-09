import { inject as service } from '@ember/service';
import { isEmpty } from '@ember/utils';
import Component from '@glimmer/component';
import { tracked } from '@glimmer/tracking';

/**
    Provides a modal dialog for rendering the `PersonaPickerComponent`.

    @module ModalComponent
    @extends Glimmer.Component
 */
export default class ModalComponent extends Component {
  @service store;
//   @tracked isNameValid = false;
//   @tracked isAgeValid = false;
//   @tracked saveDisabled = true;
//   @tracked newCandidate;

//   get isNameValid() {
//     debugger
//     return !isEmpty(this.newCandidate.name);
//   }

//   get isAgeValid() {
//     const age = this.newCandidate.age;

//     return !isEmpty(age) && +age > 0 && +age < 150;
//   }

//   get saveDisabled() {debugger
//     return !this.isAgeValid || !this.isNameValid;
//   }

  constructor(...args) {
    super(...args);

    this.newCandidate = this.store.createRecord('applicant', {
      age: '',
      name: '',
    });
  }
}
