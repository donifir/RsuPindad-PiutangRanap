import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  data: any;
  norawat: any;
}

const FindTextComponent: FC<Props> = (props) => {
  const filteredData = props.data.filter((item:any) => item.no_rawat=== props.norawat);
  const sum = filteredData.reduce((accumulator:any, item:any) => {
    return accumulator + item.biaya_rawat;
  }, 0);

  // console.log(sum);
  
  return (
    <>
      {formatRupiah(sum)}
    </>
  )
}

export default FindTextComponent