import { AlertController } from '@ionic/angular';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit {

  code ="234-543-567"
  emet = true
  recep = false
  montant : number = 0
  frais : number = 0
  total : any = 0
  cssEmet : any = ''
  cssRecep : any = 'recep'
  retraitForm : FormGroup |any
  constructor( private alertController : AlertController ) { }

  ngOnInit() {
    this.retraitForm = new FormGroup({
      cni: new FormControl('', Validators.required)
    })
  }

  retraitMontant(){

  }

  pageSuivante(){
    this.emet = false
    this.recep = true
    this.cssEmet = 'emet'
    this.cssRecep = ''
  }

  firstPage(){
    this.emet = true
    this.recep = false
    this.cssEmet = ''
    this.cssRecep = 'recep'
  }

  showAlert(){
    this.alertController.create({
      header: 'Confirmation',
      message: `<h6 > Bénéficiaire</h6>
                <p> Mbaye NDIAYE </p>

                <h6> TÉLÉPHONE</h6>
                <p> 78-789-54-34</p>

                <h6> N° CNI</h6>
                <p> 123451998700098</p>

                <h6 > Montant Reçu</h6>
                <p> 300.000 </p>

                <h6> Emetteur</h6>
                <p> Mbaye DIOP</p>

                <h6> TÉLÉPHONE</h6>
                <p> 77-777-77-77</p>
      `,

      buttons: [
        {
          text: 'Annuler',
          handler: (data: any) => {
            console.log('Canceled', data);
          }
        },
        {
          text: 'Confirmer',
          handler: (data: any) => {
            this.confimation()
          }
        }
      ]
    }).then(res => {
      res.present();
    });
  }

  async confimation(){
    const alert = await this.alertController.create({
      header: 'SUCCES',
      message: `
            <p> Retrait fait avec succès! </p>
      `,
      buttons: ['OK'],
      cssClass:'my-class'
    });
    await alert.present();
    const result = await alert.onDidDismiss();
    console.log(result);
  }

}
