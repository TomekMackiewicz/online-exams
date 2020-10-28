import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Survey, Surveys } from './survey';
import { HEADERS } from '../const/http';
import { prepareError } from '../common/functions/error.functions';
import { environment } from '../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class SurveyService {

    constructor(
        private httpClient: HttpClient
    ) {}

    getSurvey(id: number): Observable<Survey> {     
        return this.httpClient.get<Survey>(environment.admin_url+'/survey/'+id)
            .pipe(catchError(prepareError));
    }

    getSurveys(sort: string, order: string, page: number, size: number, filters: any): Observable<Surveys> { 
        let params = new HttpParams()
            .set('sort', sort)
            .set('order', order)
            .set('page', page.toString())
            .set('size', size.toString())
            .set('filters', JSON.stringify(filters));
        return this.httpClient.get<Surveys>(environment.admin_url+'/survey', {headers: HEADERS, params: params})
            .pipe(catchError(prepareError));
    }

    createSurvey(survey: Survey): Observable<Object> {
        return this.httpClient.post<Object>(environment.base_url+'/survey', survey, {headers: HEADERS})
            .pipe(catchError(prepareError));
    }

    updateSurvey(survey: Survey, id: number): Observable<any> {
        return this.httpClient.patch<any>(environment.base_url+'/survey/'+id, survey, {headers: HEADERS})
            .pipe(catchError(prepareError));
    }
       
    deleteSurveys(ids: Array<number>): Observable<string> {            
        return this.httpClient.request<string>('delete', environment.admin_url+'/survey', { body: ids })
            .pipe(catchError(prepareError));
    }

}