import { Controller } from '@hotwired/stimulus';
export default class extends Controller {
    static targets = ['optionSelected','optionSelectedDefault','selection']
    connect() {
        console.log("Début de l'application")
    }
    /**
     *
     * @param {object} event
     */
    changement(event){
        if(this.optionSelectedDefaultTarget) {
           this.selectionTarget.disabled = true
        }
        this.selectionTarget.removeAttribute("disabled")
    }
}
