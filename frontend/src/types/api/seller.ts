export interface FetchSellersParams {
  limit?: number;
  offset?: number;
  filter?: string;
}

export interface ResendDailyOrderReport {
    date: string;
}

export interface SellerResponse {
    id: number;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}

export interface SellerRequest {
    name?: string;
    email?: string;
}