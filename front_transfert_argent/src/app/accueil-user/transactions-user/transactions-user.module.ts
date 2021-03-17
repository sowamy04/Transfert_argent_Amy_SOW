import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TransactionsUserPageRoutingModule } from './transactions-user-routing.module';

import { TransactionsUserPage } from './transactions-user.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TransactionsUserPageRoutingModule
  ],
  declarations: [TransactionsUserPage]
})
export class TransactionsUserPageModule {}
