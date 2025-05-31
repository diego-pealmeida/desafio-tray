export interface LoginResponse {
    access_token: string
    expires_at: string | null
}

export interface LoginPayload {
    email: string;
    password: string;
    remember_me?: boolean;
};