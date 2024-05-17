import ComponentButtonLink from '@/components/ComponentButtonLink';
import { formatRupiah } from '@/components/FormatRupiah';
import axios from 'axios';
import Link from 'next/link'
import { useRouter } from 'next/router';
import React, { useEffect, useState } from 'react'
import { BiEdit } from 'react-icons/bi';

const TableComponent = () => {
  const [datas, setDatas] = useState<any>([])

  const router = useRouter();
  const id = router.query.slug

  async function getData() {
    try {
      const response = await axios.get(`/data-adjust/${id}`);
      console.log(response.data.data);
      setDatas(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    if (id) {
      getData()
    }
  }, [String(id)])


  return (
    <div>
      <table className="w-full flex flex-wrap table">
        <thead>
          <tr>
            <th ></th>
            <th >Kode Barang</th>
            <th >Nama Barang</th>
            <th >Qty</th>
            <th >Harsat</th>
            <th >Nilai</th>
            <th >Aksi</th>
          </tr>
        </thead>
        <tbody>
          {datas
            .map((data: any, index: any) => (
              <tr key={index}>
                <td >{index + 1}</td>
                <td >{data.kode_brng}</td>
                <td >{data.nama_item}</td>
                <td >{data.qty}</td>
                <td >{formatRupiah(data.harsat)}</td>
                <td >{formatRupiah(data.nilai)}</td>
                <td >
                  <div className='w-28'>
                    <ComponentButtonLink label="Detail" link={`/logfar/barang/${data.id}`} icon={<BiEdit />} bg="bg-slate-800" styleText="text-slate-100" />
                  </div>
                </td>
              </tr>
            ))}
        </tbody>
      </table>
    </div>
  )
}

export default TableComponent