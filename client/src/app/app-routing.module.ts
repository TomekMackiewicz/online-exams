import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { SurveyCreateComponent } from './survey/survey-create.component';

const routes: Routes = [
    { 
      path: 'dashboard', component: DashboardComponent 
    },
    {
      path: 'survey/add', component: SurveyCreateComponent
    }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
