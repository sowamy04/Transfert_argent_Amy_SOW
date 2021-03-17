import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AccueilAdminPage } from './accueil-admin.page';

const routes: Routes = [
  {
    path: '',
    component: AccueilAdminPage,
    children:[
      {
        path: 'home-admin',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./home-admin/home-admin.module').then( m => m.HomeAdminPageModule)
          },
        ]
      },
      {
        path: 'home-admin/home-admin',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./home-admin/home-admin.module').then( m => m.HomeAdminPageModule)
          },
        ]
      },
      {
        path: 'trans-admin',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./transaction-admin/transaction-admin.module').then( m => m.TransactionAdminPageModule)
          },
        ]
      },
      {
        path: 'home-admin/trans-admin',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./transaction-admin/transaction-admin.module').then( m => m.TransactionAdminPageModule)
          },
        ]
      },
      {
        path: 'commission',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./commission/commission.module').then( m => m.CommissionPageModule)
          },
        ]
      },
      {
        path: 'home-admin/commission',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./commission/commission.module').then( m => m.CommissionPageModule)
          },
        ]
      },
      {
        path: 'calc',
        children :
        [
          {
            path: '',
            loadChildren: () => import('../accueil-user/calculatrice-user/calculatrice-user.module').then( m => m.CalculatriceUserPageModule)
          },
        ]
      },
      {
        path: 'home-admin/calc',
        children :
        [
          {
            path: '',
            loadChildren: () => import('../accueil-user/calculatrice-user/calculatrice-user.module').then( m => m.CalculatriceUserPageModule)
          },
        ]
      },
      {
        path: 'home-admin/depot',
        children :
        [
          {
            path: '',
            loadChildren: () => import('../transactions/depot/depot.module').then( m => m.DepotPageModule)
          },
        ]
      },
      {
        path: 'home-admin/retrait',
        children :
        [
          {
            path: '',
            loadChildren: () => import('../transactions/retrait/retrait.module').then( m => m.RetraitPageModule)
          },
        ]
      },
      {
        path : '',
        redirectTo : '/admin/home-admin',
        pathMatch : 'full'
      }
    ]
  },
  {

  },
  {

  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AccueilAdminPageRoutingModule {}
