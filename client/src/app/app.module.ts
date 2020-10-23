import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { HttpClient, HTTP_INTERCEPTORS } from '@angular/common/http';

import { AppComponent } from './app.component';

import { FlexLayoutModule } from '@angular/flex-layout';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';

import { DashboardModule } from './dashboard/dashboard.module';
import { SurveyModule } from './survey/survey.module';

import { ApplicationPipesModule } from './pipes/application-pipes.module';

import { NavigationComponent } from './menu-list-item/navigation.component';

import { NavService } from './menu-list-item/nav.service';

import { CapitalizeFirstPipe } from './pipes/capitalize-first.pipe';

import { TranslateModule, TranslateLoader } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';

@NgModule({
  declarations: [
    AppComponent,
    NavigationComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    FlexLayoutModule,
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    MatToolbarModule,
    DashboardModule,
    SurveyModule,
    ApplicationPipesModule,
    TranslateModule.forRoot({
      loader: {
          provide: TranslateLoader,
          useFactory: HttpLoaderFactory,
          deps: [HttpClient]
      }
    })
  ],
  providers: [
    NavService,
    CapitalizeFirstPipe,
    // { 
    //   provide: HTTP_INTERCEPTORS, 
    //   useClass: LoaderInterceptor, 
    //   multi: true 
    // },
    // {
    //   provide: HTTP_INTERCEPTORS,
    //   useClass: TokenInterceptor,
    //   multi: true
    // }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http, "./assets/i18n/", ".json");
}