import { AlertController } from '@ionic/angular';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-depot',
  templateUrl: './depot.page.html',
  styleUrls: ['./depot.page.scss'],
})
export class DepotPage implements OnInit {

  emet = false
  recep = true
  montant : number = 0
  frais : number = 0
  total : any = 0
  cssEmet : any = 'emet'
  cssRecep : any = ''
  depotForm : FormGroup
  constructor(private alertController : AlertController) { }

  ngOnInit() {
    this.frais = this.fraissolde(this.montant)
    this.total
    this.depotForm = new FormGroup({
      cni: new FormControl('', Validators.required),
      nom: new FormControl('', Validators.required),
      prenom: new FormControl('', Validators.required),
      numDepot: new FormControl('', Validators.required),
      nomRetrait: new FormControl('', Validators.required),
      prenomRetrait: new FormControl('', Validators.required),
      numRetrait: new FormControl('', Validators.required),
      montant: new FormControl('', Validators.required)
   });
  }

  depotMontant(){

  }

  pageSuivante(){
    this.emet = true
    this.recep = false
    this.cssEmet = ''
    this.cssRecep = 'recep'
  }

  firstPage(){
    this.emet = false
    this.recep = true
    this.cssEmet = 'emet'
    this.cssRecep = ''
  }

  showAlert(){
    this.alertController.create({
      header: 'Confirmation',
      message: `<h6 > Emetteur</h6>
                <p> Mbaye DIOP </p>

                <h6> Téléphone</h6>
                <p> 78-789-54-34</p>

                <h6> N° CNI</h6>
                <p> 123451998700098</p>

                <h6 > Montant à envoyer</h6>
                <p> 300.000 </p>

                <h6> Recepteur</h6>
                <p> Mbaye NDIAYE</p>

                <h6> Numéro à envoyer</h6>
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
      header: 'Transfert réussi',
      message: `
            <h6> INFOS </h6>
            <p> Vous avez envoyé ` +this.depotForm.value.montant+ ` à ` + this.depotForm.value.prenomRetrait+` ` + this.depotForm.value.nomRetrait+ `</p>
            <h6> CODE DE TRANSACTION </h6>
            <p> 456-566-787</p>
      `,
      buttons: ['OK'],
      cssClass:'my-class'
    });
    await alert.present();
    const result = await alert.onDidDismiss();
    console.log(result);
  }

  fraissolde(solde : any){
    if (solde == 0){
      return 0;
    }
    else if(solde>0 && solde<=5000){
      return 425;
    }
    else if(solde>=5001 && solde<=10000){
      return 850;
    }
    else if(solde>=10001 && solde<=15000){
      return 1270;
    }
    else if(solde>=15001 && solde<=20000){
      return 1695;
    }
    else if(solde>=20001 && solde<=50000){
      return 2500;
    }
    else if(solde>=50001 && solde<=60000){
      return 3000;
    }
    else if(solde>=60001 && solde<=75000){
      return 4000;
    }
    else if(solde>=75001 && solde<=120000){
      return 5000;
    }
    else if(solde>=120001 && solde<=150000){
      return 6000;
    }
    else if(solde>=150001 && solde<=200000){
      return 7000;
    }
    else if(solde>=200001 && solde<=250000){
      return 8000;
    }
    else if(solde>=250001 && solde<=300000){
      return 9000;
    }
    else if(solde>=300001 && solde<=400000){
      return 12000;
    }
    else if(solde>=400001 && solde<=750000){
      return 15000;
    }
    else if(solde>=750001 && solde<=900000){
      return 22000;
    }
    else if(solde>=900001 && solde<=1000000){
      return 25000;
    }
    else if(solde>=1000001 && solde<=1125000){
      return 27000;
    }
    else if(solde>=1125001 && solde<=2000000){
      return 30000;
    }
    else if(solde>=2000001){
      return (solde * 2)/100;
    }
  }

  totalMoney( montant : number, frais :number){
    this.total =  +montant;
    this.total = +frais;
    return this.total
  }

}
