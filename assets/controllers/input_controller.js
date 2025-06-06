import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['choice_selected', 'input_libelle_disabled', 'input_date_debut_disabled',
        'input_date_fin_disabled', 'input_date_commission_disabled']
    connect() {
    }
    input_disabled(event){
        if(this.isValuePresent(this.input_libelle_disabledTarget.value) || this.isValuePresent(this.input_date_debut_disabledTarget.value) || this.isValuePresent(this.input_date_fin_disabledTarget.value) || this.isValuePresent(this.input_date_commission_disabledTarget.value)) {
            this.choice_selectedTarget.disabled = true
        } else {
            this.choice_selectedTarget.removeAttribute("disabled")
        }
    }
    choice_disabled(event){
        if(this.isChoiceValuePresent(this.choice_selectedTarget.value)){
            this.input_libelle_disabledTarget.disabled = true
            this.input_date_debut_disabledTarget.disabled = true
            this.input_date_fin_disabledTarget.disabled = true
            this.input_date_commission_disabledTarget.disabled = true
        } else {
            this.input_libelle_disabledTarget.removeAttribute("disabled")
            this.input_date_debut_disabledTarget.removeAttribute("disabled")
            this.input_date_fin_disabledTarget.removeAttribute("disabled")
            this.input_date_commission_disabledTarget.removeAttribute("disabled")

        }
    }
    isValuePresent(val){
        if (typeof val === 'string') return val.length > 0;
    }
    isChoiceValuePresent(val){
        if(val !== 'Séléctionner votre itération') return val.length > 0
    }
}