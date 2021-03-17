import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalculatriceUserPageRoutingModule } from './calculatrice-user-routing.module';

import { CalculatriceUserPage } from './calculatrice-user.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalculatriceUserPageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [CalculatriceUserPage]
})
export class CalculatriceUserPageModule {}
