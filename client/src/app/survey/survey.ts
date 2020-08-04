import { Question } from '../question/question';

export interface Survey {
    id: number;
    title: string;
    description: string;
    summary: string;
    duration: number;
    nextSubmissionAfter: number;
    ttl: number;
    usePagination: boolean;
    questionsPerPage: number;
    shuffleQuestions: boolean;
    immediateAnswers: boolean;
    restrictSubmissions: boolean;
    allowedSubmissions: number;
    questions: Question[];
}

export interface Surveys {
    surveys: Survey[];
    count: number;
}