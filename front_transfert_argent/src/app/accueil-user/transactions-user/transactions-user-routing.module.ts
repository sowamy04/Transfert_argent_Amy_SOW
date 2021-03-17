import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TransactionsUserPage } from './transactions-user.page';

const routes: Routes = [
  {
    path: '',
    component: TransactionsUserPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TransactionsUserPageRoutingModule {}
