document.addEventListener('DOMContentLoaded', function () {

    const sSelector = 'form'; // '.noEmptyFields';
    const oFormElement = this.querySelector(sSelector);

    oFormElement.addEventListener('submit', function (oEvent) {

        let oFields = this.elements;
        let bAllFieldsEmpty = true;
        
        for (let i = 0; i < oFields.length; i++) {
            if (this.elements[i].value === '') {
                this.elements[i].name = '';
            } else {
                bAllFieldsEmpty = false;
            }
        }

        if (bAllFieldsEmpty) {
            oEvent.preventDefault();
        }

    });

});
