import type { SellerResponse } from "./seller";

export interface OrderResponse {
    id: number;
    value: number;
    value_formated: string;
    date: string;
    date_formated: string;
    seller: SellerResponse;
    seller_name: string;
    commission: string;
    created_at: string;
    updated_at: string;
}

export interface OrderRequest {
    seller_id?: number;
    date?: string;
    value?: number;
}

export interface FetchOrdersParams {
  limit?: number;
  offset?: number;
  seller_id?: string;
  date_start?: string;
  date_end?: string;
}