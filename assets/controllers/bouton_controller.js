import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.innerHTML = 'You have installed Stimulus, yes ?';
    }
}