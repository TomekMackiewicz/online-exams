import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './user/login/login.component';
import { FrontComponent } from './front/front.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { SurveyCreateComponent } from './survey/survey-create.component';

const routes: Routes = [
    { 
      path: 'login', component: LoginComponent 
    },
    { 
        path: 'front', component: FrontComponent
    },
    { 
      path: 'admin/dashboard', component: DashboardComponent 
    },
    {
      path: 'admin/survey/add', component: SurveyCreateComponent
    }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
