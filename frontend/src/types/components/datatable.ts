import type { ListResponse } from "../api"

export interface Column {
  label: string
  key?: string
  slot?: string
}

export interface Pagination {
  offset: number
  limit: number
}

export interface FetchApiParams {
    offset: number
    limit: number
    filters?: Record<string, any>
}

export interface DatatableProps<D = any> {
    columns: Column[]
    fetchApi: (params: FetchApiParams) => Promise<ListResponse<D>>
    filters?: Record<string, any>
    refresh?: boolean
}