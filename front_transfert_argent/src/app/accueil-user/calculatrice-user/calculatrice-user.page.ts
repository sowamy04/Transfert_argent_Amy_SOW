import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-calculatrice-user',
  templateUrl: './calculatrice-user.page.html',
  styleUrls: ['./calculatrice-user.page.scss'],
})
export class CalculatriceUserPage implements OnInit {

  depot= "Dépôt";
  calcForm : FormGroup
  frais : any
  constructor(private alertCtrl : AlertController) { }

  ngOnInit() {
    this.calcForm = new FormGroup({
      montant: new FormControl('', Validators.required)
   });
  }

  async calculFrais(){
    this.frais =  this.fraissolde(this.calcForm.value.montant)
    const alert = await this.alertCtrl.create({
      header: 'Calculateur',
      subHeader: 'Pour une transaction de '+ this.calcForm.value.montant+ 'F CFA, le frais est égal à:',
      message: this.frais,
      buttons: ['Retour'],
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

}
