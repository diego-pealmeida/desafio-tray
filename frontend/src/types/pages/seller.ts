import type { SellerResponse } from "../api/seller";

export interface ResendDailyReportProps {
    show: boolean;
    seller: SellerResponse | null
}

export interface ConfirmDeleteProps {
    show: boolean;
    seller: SellerResponse | null
}