export const formatRupiah = (number:any) => {
  const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  });

  return formatter.format(number);
};