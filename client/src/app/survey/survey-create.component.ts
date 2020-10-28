import { Component, OnInit, ChangeDetectionStrategy, ChangeDetectorRef } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { SurveyService } from './survey.service';
//import { CategoryService } from '../category/category.service';
import { UiService } from '../common/services/ui.service';
import { handleError } from '../common/functions/error.functions';
import { Question } from '../question/question';
import { QuestionType } from '../const/questionType';
//import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';

@Component({
    selector: 'app-survey-create',
    templateUrl: './survey-create.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush
})
export class SurveyCreateComponent implements OnInit {

    formChanged: boolean = false;
    surveyTitle: string;
    questionLabel: string;
    questions: Question[] = [];
    durationPattern = { 
        '0': { pattern: new RegExp('\[0-9\]')},
        '1': { pattern: new RegExp('\[0-5\]')} 
    };

    //picker;

    questionTypes: QuestionType[] = [
        {value: 'steak-0', viewValue: 'Steak'},
        {value: 'pizza-1', viewValue: 'Pizza'},
        {value: 'tacos-2', viewValue: 'Tacos'}
      ];

    //editor = ClassicEditor;
    surveyForm = this.fb.group({
        title: ['', Validators.required],
        description: [''],
        summary: [''],
        duration: [''],
        next_submission_after: [''],
        ttl: [''],
        use_pagination: [''],
        questions_per_page: {value: null, disabled: true},
        shuffle_questions: [''],
        immediate_answers: [''],
        restrict_submissions: [''],
        allowed_submissions: {value: null, disabled: true},
        //questions: [this.questions]
    });

    questionForm = this.fb.group({
        label: ['', Validators.required],
        description: [''],
        type: ['', Validators.required],
        hint: [''],
        isRequired: ['', Validators.required],
        shuffleAnswers: ['']
    });

    constructor(
        private router: Router,
        private surveyService: SurveyService,
        //private categoryService: CategoryService,
        private uiService: UiService,
        private fb: FormBuilder,
        private ref: ChangeDetectorRef
    ) { }
    
    ngOnInit(): void {
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

        this.surveyForm.get('use_pagination').valueChanges.subscribe(use_pagination => {
            if (use_pagination !== true) {
                this.surveyForm.get('questions_per_page').reset();
                this.surveyForm.get('questions_per_page').disable();
            }
            else {
                this.surveyForm.get('questions_per_page').enable();
            }
        });

        this.surveyForm.get('restrict_submissions').valueChanges.subscribe(restrict_submissions => {
            if (restrict_submissions !== true) {
                this.surveyForm.get('allowed_submissions').reset();
                this.surveyForm.get('allowed_submissions').disable();
            }
            else {
                this.surveyForm.get('allowed_submissions').enable();
            }
        });
    }

    saveSurvey() {
        return this.surveyService.createSurvey(this.surveyForm.getRawValue()).subscribe(
            success => {
                this.formChanged = false;
                this.uiService.openSnackBar(success, 'success-notification-overlay');
                this.ref.detectChanges();
            },
            error => {
                let errors = handleError(error, this.surveyForm);
                if (errors !== null && typeof errors.message !== 'undefined') {
                    this.uiService.openSnackBar(errors.message, 'error-notification-overlay');
                }
                this.ref.detectChanges();
            }
        );
    }

    delete() {
        
    }

    saveQuestion() {

    }

    clearQuestion() {

    }

}