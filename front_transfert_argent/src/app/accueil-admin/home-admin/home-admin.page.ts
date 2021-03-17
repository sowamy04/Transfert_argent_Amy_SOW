import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home-admin',
  templateUrl: './home-admin.page.html',
  styleUrls: ['./home-admin.page.scss'],
})
export class HomeAdminPage implements OnInit {

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
        url   : "home-admin",
        icon  : "home"
      },
      {
        title : "Transaction",
        url   : "trans-admin",
        icon  : "time"
      },
      {
        title : "Commission",
        url   : "commission",
        icon  : "contacts"
      },
      {
        title : "Calculateur",
        url   : "calc",
        icon  : "calculator"
      },
    ]
  }

}
