import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-transaction-admin',
  templateUrl: './transaction-admin.page.html',
  styleUrls: ['./transaction-admin.page.scss'],
})
export class TransactionAdminPage implements OnInit {

  touteTrans = false
  meTrans = true
  cssToute = "toute"
  cssMes=""
  constructor() { }

  ngOnInit() {
  }

  toutesTrans(){
    this.touteTrans = false
    this.meTrans = true
    this.cssToute = "toute"
    this.cssMes=""
  }

  mesTrans(){
    this.touteTrans = true
    this.meTrans = false
    this.cssToute = ""
    this.cssMes="mes"
  }

}
