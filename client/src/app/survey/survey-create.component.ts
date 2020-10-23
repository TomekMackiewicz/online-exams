import { Component, OnInit, ChangeDetectionStrategy, ChangeDetectorRef } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { SurveyService } from './survey.service';
//import { CategoryService } from '../category/category.service';
//import { UiService } from '../../common/services/ui.service';
import { handleError } from '../common/functions/error.functions';
import { Question } from '../question/question';
//import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';

@Component({
    selector: 'app-survey-create',
    templateUrl: './survey-create.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush
})
export class SurveyCreateComponent implements OnInit {

    formChanged: boolean = false;
    surveyTitle: 'new';
    questions: Question[] = [];
    //editor = ClassicEditor;
    surveyForm = this.fb.group({
        title: ['', Validators.required],
        description: [''],
        summary: [''],
        duration: [''],
        nextSubmissionAfter: [''],
        ttl: [''],
        usePagination: [''],
        questionsPerPage: [''],
        shuffleQuestions: [''],
        immediateAnswers: [''],
        restrictSubmissions: [''],
        allowedSubmissions: [''],
        questions: [this.questions]
    });

    constructor(
        private router: Router,
        private surveyService: SurveyService,
        //private categoryService: CategoryService,
        //private uiService: UiService,
        private fb: FormBuilder,
        private ref: ChangeDetectorRef
    ) { }
    
    ngOnInit(): void {
        this.surveyForm.get('questionsPerPage').disable();
        this.surveyForm.get('allowedSubmissions').disable();
        this.onChanges();
        //
        // this.categoryService.getCategories().subscribe(
        //     data => {
        //         this.categories = data.categories;
        //     },
        //     error => {
        //         console.log(error); // TODO: handle error
        //     }
        // );
    }

    onChanges(): void {
        this.surveyForm.valueChanges.subscribe(val => {
            console.log('formChanged');
            this.formChanged = true;
        });

        this.surveyForm.get('usePagination').valueChanges.subscribe(usePagination => {
            if (usePagination !== true) {
                this.surveyForm.get('questionsPerPage').reset();
                this.surveyForm.get('questionsPerPage').disable();
            }
            else {
                this.surveyForm.get('questionsPerPage').enable();
            }
        });

        this.surveyForm.get('restrictSubmissions').valueChanges.subscribe(restrictSubmissions => {
            if (restrictSubmissions !== true) {
                this.surveyForm.get('allowedSubmissions').reset();
                this.surveyForm.get('allowedSubmissions').disable();
            }
            else {
                this.surveyForm.get('allowedSubmissions').enable();
            }
        });
    }

    saveSurvey() {
        console.log('saveSurvey');
        this.formChanged = false; // przenieść do success
        // return this.surveyService.createSurvey(this.surveyForm.value).subscribe(
        //     success => {
        //         //this.formChanged = false;
        //         //this.uiService.openSnackBar(success, 'success-notification-overlay');
        //         //this.router.navigate(['/admin/survey']);
        //     },
        //     error => {
        //         let errors = handleError(error, this.surveyForm);
        //         if (errors !== null && typeof errors.message !== 'undefined') {
        //             //this.uiService.openSnackBar(errors.message, 'error-notification-overlay');
        //         }
        //         this.ref.detectChanges();
        //     }
        // );
    }

    delete() {
        //this.router.navigate(['/admin/survey']);
    }

}