import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TransactionAdminPage } from './transaction-admin.page';

const routes: Routes = [
  {
    path: '',
    component: TransactionAdminPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TransactionAdminPageRoutingModule {}
