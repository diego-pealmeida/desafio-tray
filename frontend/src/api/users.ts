import { apiHandler } from "@/hooks/useApiHandler";
import api from "@/plugins/axios";
import type { UserResponse } from "@/types/api/user";

export const getMe = async (): Promise<UserResponse> => {
    return apiHandler<UserResponse>(() => api.get('/users/me'));
};