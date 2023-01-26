import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionContainer"]

    static values = {
        index    : Number,
        prototype: String,
        indexStep : Number
    }

    addCollectionElement(event)
    {
        this.indexValue++;
        const item = document.createElement('div');
        const proto = `<p> Etape ${this.indexValue} : </p>` + this.prototypeValue.replace(/__name__/g, this.indexValue);
        item.innerHTML = proto;
        this.collectionContainerTarget.appendChild(item);

        //Delete button
        const deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'Supprimer';
        deleteButton.addEventListener('click', () => {
            item.remove();
        });
        item.appendChild(deleteButton);

    }

    deleteCollectionElement(event) {
        console.log('coucou');
    }

    connect() {
        this.collectionContainerTarget.addEventListener("click", (event) => {
                this.indexValue = 3;
                this.deleteCollectionElement(event);

        });
    }

}