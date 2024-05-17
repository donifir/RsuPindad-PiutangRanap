import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  data: any;
  norawat: any;
}

const FindOperasiComponent: FC<Props> = (props) => {
  const filteredData = props.data.filter((item:any) => item.no_rawat=== props.norawat);
  const sum = filteredData.reduce((accumulator:any, item:any) => {
    return accumulator + item.total_operasi;
  }, 0);  
  
  return sum
}

export default FindOperasiComponent