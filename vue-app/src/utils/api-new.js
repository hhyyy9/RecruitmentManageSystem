import request from "@/utils/request-h5";

export async function getpositionlist(params) {
  return await request.get("api/getpositionlist", params);
}

/**
 * @description
 *
 * @export
 * @param {obj} params
 */
export async function publishposition(params) {
  return await request.post("api/publishposition", params);
}

/**
 * @description
 *
 * @export
 * @param {obj} params
 */
export async function updateposition(params) {
  return await request.post("api/updateposition", params);
}

/**
 * @description
 *
 * @export
 * @param {obj} params
 */
export async function apply(params) {
  return await request.post("api/apply", params);
}

export async function getappliedinfolist(params) {
  return await request.get("api/getappliedinfolist", params);
}

export async function editappliedinfo(params) {
  return await request.get("api/editappliedinfo", params);
}

export async function login(params) {
  return await request.post("api/login", params);
}
