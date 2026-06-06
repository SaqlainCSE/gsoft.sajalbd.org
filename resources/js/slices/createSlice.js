import { buildCreateSlice, asyncThunkCreator } from '@reduxjs/toolkit'

// name is up to you
export const createSlice = buildCreateSlice({
  creators: { asyncThunk: asyncThunkCreator },
})