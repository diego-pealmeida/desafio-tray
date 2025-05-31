import { apiHandler } from "@/hooks/useApiHandler";
import api from "@/plugins/axios";
import type { LoginPayload, LoginResponse } from "@/types/api/auth";

export const login = async (payload: LoginPayload): Promise<LoginResponse> => {
    return apiHandler<LoginResponse>(() => api.post('/auth/login', payload));
};

export const logout = async (): Promise<unknown> => {
    return new Promise((resolve, reject) => {
        apiHandler<unknown>(() => api.post('/auth/logout'))
        .then(response => {
            localStorage.removeItem('token')
            localStorage.removeItem('token_expires_at')
            localStorage.removeItem('user')
            resolve(response)
        })
        .catch(reject)
    });
};