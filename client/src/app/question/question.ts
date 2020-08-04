import { Answer } from '../answer/answer';

export interface Question {
    id: number;
    label: string;
    description: string;
    type: string;
    hint: string;
    is_required: boolean;
    shuffle_answers: boolean;
    answers: Answer[];
}