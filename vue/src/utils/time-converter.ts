/* eslint-disable import/prefer-default-export */

export function toPhpDate(date: Date): string {
  return `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
}

export function toReadableDate(datestring: string): string {
  const date = new Date(datestring);
  return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
}
