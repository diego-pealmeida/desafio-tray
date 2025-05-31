import { apiHandler } from "@/hooks/useApiHandler";
import api from "@/plugins/axios";
import type { ListResponse } from "@/types/api";
import type { FetchOrdersParams, OrderRequest, OrderResponse } from "@/types/api/order";

export const getOrders = async (params: FetchOrdersParams): Promise<ListResponse<OrderResponse>> => {
  return apiHandler<ListResponse<OrderResponse>>(() => api.get('/orders', { params }));
};

export const createOrder = (payload: OrderRequest): Promise<OrderResponse> => {
  return apiHandler<OrderResponse>(() => api.post('/orders', payload));
};

export const updateOrder = async (orderId: number, payload: any): Promise<unknown> => {
  return apiHandler<unknown>(() => api.put(`/orders/${orderId}`, payload));
};

export const deleteOrder = (id: number): Promise<unknown> => {
  return apiHandler<unknown>(() => api.delete(`/orders/${id}`));
};
