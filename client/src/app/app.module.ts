import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';

import { DashboardModule } from './dashboard/dashboard.module';
import { ApplicationPipesModule } from './pipes/application-pipes.module';

import { NavigationComponent } from './menu-list-item/navigation.component';

import { NavService } from './menu-list-item/nav.service';

import { CapitalizeFirstPipe } from './pipes/capitalize-first.pipe';

@NgModule({
  declarations: [
    AppComponent,
    NavigationComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    MatToolbarModule,
    DashboardModule,
    ApplicationPipesModule
  ],
  providers: [
    NavService,
    CapitalizeFirstPipe
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
