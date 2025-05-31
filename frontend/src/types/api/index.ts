export interface ErrorResponse {
  errors: string[]
}

export interface ListResponse<D = any> {
  data: D[];
  total: number;
  total_filtered: number;
}