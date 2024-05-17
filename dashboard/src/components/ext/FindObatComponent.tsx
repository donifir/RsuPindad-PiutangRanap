import { Console } from 'console';
import React, { FC, } from 'react'
import { formatRupiah } from '../FormatRupiah';
type Props = {
  data: any;
  norawat: any;
}

const FindObatComponent: FC<Props> = (props) => {
  const filteredData = props.data.filter((item:any) => item.no_rawat=== props.norawat);
  const sum = filteredData.reduce((accumulator:any, item:any) => {
    return accumulator + item.total;
  }, 0);  
  
  return sum
}

export default FindObatComponent