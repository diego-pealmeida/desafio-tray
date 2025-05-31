import type { OrderResponse } from "../api/order";
import type { SellerResponse } from "../api/seller";

export interface ConfirmDeleteProps {
    show: boolean;
    order: OrderResponse | null
}

export interface FormModalProps {
    show: boolean
    order?: OrderResponse | null
}

export interface FormModalForm {
    seller: SellerResponse | null,
    date: string,
    value: number | string,
}