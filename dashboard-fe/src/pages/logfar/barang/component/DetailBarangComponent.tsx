import ComponentButtonLink from '@/components/ComponentButtonLink';
import { FormatMataUang } from '@/components/FormatMataUang';
import axios from 'axios';
import React, { FC, useEffect, useState } from 'react'
import { BiEdit } from 'react-icons/bi';
import DeleteSatuDataComponent from './DeleteSatuDatabarang';

type Props = {
  id: any;
}

const DetailBarangComponent: FC<Props> = (props) => {
  const [data, setData] = useState<any>([])

  async function getDatas() {
    try {
      const response = await axios.get(`/data-adjust/barang/${props.id}`);
      setData(response.data.data)
      console.log(response.data.data, 'ini responses');
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    if (props.id) {
      getDatas()
    }

  }, [String(props.id)])



  return (
    <div>
      <div className="w-[100%] p-3 my-auto">
        <h2 className="card-title border p-2 rounded-md">Detail Barang</h2>
        <div className="border p-2 rounded-md mt-3 relative ">

          <div className="flex flex-row w-[100%]">
            <p className="w-[26%]">Kode Barang</p>
            <p className="w-[4%]">:</p>
            <p className="w-[70%] truncate">{data.kode_brng}</p>
          </div>

          <div className="flex flex-row w-[100%] mt-4">
            <p className="w-[26%]">Nama Barang</p>
            <p className="w-[4%]">:</p>
            <p className="w-[70%] truncate">{data.nama_item}</p>
          </div>

          <div className="flex flex-row w-[100%] mt-4">
            <p className="w-[26%]">Qty</p>
            <p className="w-[4%]">:</p>
            <p className="w-[70%] truncate">{data.qty}</p>
          </div>

          <div className="flex flex-row w-[100%] mt-4">
            <p className="w-[26%]">Harsat</p>
            <p className="w-[4%]">:</p>
            <p className="w-[70%] truncate">{FormatMataUang(data.harsat)}</p>
          </div>

          <div className="flex flex-row w-[100%] mt-4">
            <p className="w-[26%]">Nilai</p>
            <p className="w-[4%]">:</p>
            <p className="w-[70%] truncate">{FormatMataUang(data.nilai)}</p>
          </div>

        </div>
      </div>

      <div className="modal-action mx-4">
        <div className="flex flex-row gap-2">
          <ComponentButtonLink label="Edit" link={`/logfar/barang/edit/${data?.id}`} icon={<BiEdit />} bg="bg-slate-800" styleText="text-slate-100" />
          <DeleteSatuDataComponent id={data?.id} label={data?.nama_item} />
        </div>
      </div>
    </div>
  )
}

export default DetailBarangComponent