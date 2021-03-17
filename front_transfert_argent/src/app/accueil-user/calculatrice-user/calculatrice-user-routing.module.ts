import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CalculatriceUserPage } from './calculatrice-user.page';

const routes: Routes = [
  {
    path: '',
    component: CalculatriceUserPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CalculatriceUserPageRoutingModule {}
