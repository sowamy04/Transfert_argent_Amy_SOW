import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TransactionAdminPageRoutingModule } from './transaction-admin-routing.module';

import { TransactionAdminPage } from './transaction-admin.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TransactionAdminPageRoutingModule
  ],
  declarations: [TransactionAdminPage]
})
export class TransactionAdminPageModule {}
