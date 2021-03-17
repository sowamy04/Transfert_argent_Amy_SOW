import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AccueilUserPage } from './accueil-user.page';

const routes: Routes = [
  {
    path: '',
    component: AccueilUserPage,
    children:[
      {
        path: 'home-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./home-user/home-user.module').then( m => m.HomeUserPageModule)
          },
        ]
      },
      {
        path: 'home-user/home-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./home-user/home-user.module').then( m => m.HomeUserPageModule)
          },
        ]
      },
      {
        path: 'trans-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./transactions-user/transactions-user.module').then( m => m.TransactionsUserPageModule)
          },
        ]
      },
      {
        path: 'home-user/trans-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./transactions-user/transactions-user.module').then( m => m.TransactionsUserPageModule)
          },
        ]
      },
      {
        path: 'calc-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./calculatrice-user/calculatrice-user.module').then( m => m.CalculatriceUserPageModule)
          },
        ]
      },
      {
        path: 'home-user/calc-user',
        children :
        [
          {
            path: '',
            loadChildren: () => import('./calculatrice-user/calculatrice-user.module').then( m => m.CalculatriceUserPageModule)
          },
        ]
      },
      {
        path: 'home-user/depot',
        children :
        [
          {
            path: '',
            loadChildren: () => import('../transactions/depot/depot.module').then( m => m.DepotPageModule)
          },
        ]
      },
      {
        path: 'home-user/retrait',
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
        redirectTo : '/user/home-user',
        pathMatch : 'full'
      }
    ]
  },


];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AccueilUserPageRoutingModule {}
