import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home-user',
  templateUrl: './home-user.page.html',
  styleUrls: ['./home-user.page.scss'],
})
export class HomeUserPage implements OnInit {

  navigate : any;
  eye="eye-off";
  somme: any = 250000
  cfa= "F CFA"
  montant = this.somme;
  constructor(){}

  ngOnInit(){
    this.sideMenu();
  }

  afficherCacher(){
    if (this.eye== "eye-off") {
      this.eye= "eye"
      this.montant = "-"
      this.cfa=""
    }
    else if(this.eye== "eye"){
      this.eye= "eye-off"
      this.montant= this.somme;
      this.cfa="F CFA"
    }
  }

  sideMenu()
  {
    this.navigate =
    [
      {
        title : "Home",
        url   : "home-user",
        icon  : "home"
      },
      {
        title : "Transaction",
        url   : "trans-user",
        icon  : "time"
      },
      {
        title : "Calculateur",
        url   : "calc-user",
        icon  : "calculator"
      },
    ]
  }

}
