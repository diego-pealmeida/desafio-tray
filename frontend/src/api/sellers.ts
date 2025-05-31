import { apiHandler } from "@/hooks/useApiHandler";
import api from "@/plugins/axios";
import type { ListResponse } from "@/types/api";
import type { FetchSellersParams, ResendDailyOrderReport, SellerRequest, SellerResponse } from "@/types/api/seller";

export const getSellers = async (params: FetchSellersParams): Promise<ListResponse<SellerResponse>> => {
  return apiHandler<ListResponse<SellerResponse>>(() => api.get('/sellers', { params }));
};

export const createSeller = (payload: any): Promise<SellerResponse> => {
  return apiHandler<SellerResponse>(() => api.post('/sellers', payload))
};

export const updateSeller = (sellerId: number, payload: SellerRequest): Promise<unknown> => {
  return apiHandler<SellerResponse>(() => api.put(`/sellers/${sellerId}`, payload));
};

export const deleteSeller = (sellerId: number): Promise<unknown> => {
  return apiHandler<unknown>(() => api.delete(`/sellers/${sellerId}`));
};

export const resendDailyOrderReport = (sellerId: number, payload: ResendDailyOrderReport): Promise<unknown> => {
  return apiHandler<unknown>(() => api.post(`/reports/send/orders/daily/sellers/${sellerId}`, payload));
}
