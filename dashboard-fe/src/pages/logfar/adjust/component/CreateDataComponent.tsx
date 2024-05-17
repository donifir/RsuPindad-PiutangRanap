import TextInputComponent from '@/components/input/TextInputComponent'
import { header } from '@/pages/_app';
import axios from 'axios'
import { useRouter } from 'next/router';
import React, { FC, useEffect, useState } from 'react'

import { toast } from 'react-toastify';
const notify = () => toast.success("data berhasil diupdate!");
import { Dropdown } from 'semantic-ui-react';
import 'semantic-ui-css/semantic.min.css'


type Props = {
  id: any;
}

const CreateDataComponent: FC<Props> = (props) => {
  const [dataKodeBarang, setDataKodeBarang] = useState('')
  const [dataNamaBarang, setDataNamaBarang] = useState('')
  const [dataQtyBarang, setDataQtyBarang] = useState('')
  const [dataHarsatBarang, setDataHarsatBarang] = useState('')
  const [dataNilaiBarang, setDataNilaiBarang] = useState('')
  const [error, setError] = useState<any>([])
  const router = useRouter();

  // sendData
  const onSubmits = (e: any) => {
    e.preventDefault();
    e.preventDefault();

    const formData = new FormData()
    formData.append('kode_brng', dataKodeBarang)
    formData.append('qty', dataQtyBarang)
    formData.append('harsat', dataHarsatBarang)
    formData.append('nilai', dataNilaiBarang)
    formData.append('nama_bulan', props.id)

    axios.post(`/data-adjust/barang/craete`, formData, header)
      .then(function (response) {
        console.log(response);
        router.push(`/logfar/adjust/${props.id}`)
        notify()
      })
      .catch(function (error) {
        setError(error.response.data.message);
        console.log(error.response.data.message);
      });
  }

  // getdata

  const [dataBarang, setDataBarang] = useState<any>([])
  async function getData() {
    try {
      const response = await axios.get('/data-barang');
      setDataBarang(response.data.data)
      console.log(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getData()
  }, [])


  return (
    <div>
      <form onSubmit={onSubmits}>
        <div className='flex flex-row justify-between'>
          <label className="text-slate-700">
            Kode Barang {dataKodeBarang}
          </label>
          <span className="text-red-500">{error.kode_brng ? error.kode_brng : ''}</span>
        </div>

        <Dropdown
          placeholder='Select Country'
          fluid
          search
          selection
          options={dataBarang}
          value={dataKodeBarang}
          onChange={(e: any, data: any) => setDataKodeBarang(data.value)}
        />

        {/* <TextInputComponent
          disabled={false}
          label='Kode Barang'
          value={dataKodeBarang}
          onChange={(e: any) => setDataKodeBarang(e.target.value)}
          error={error?.nama_layanan}
        />

        <TextInputComponent
          disabled={true}
          label='Nama Barang'
          value={dataNamaBarang}
          onChange={(e: any) => setDataNamaBarang(e.target.value)}
          error={error?.nama_layanan}
        /> */}

        <TextInputComponent
          disabled={false}
          label='Qty'
          value={dataQtyBarang}
          onChange={(e: any) => setDataQtyBarang(e.target.value)}
          error={error?.qty}
        />

        <TextInputComponent
          disabled={false}
          label='Harsat'
          value={dataHarsatBarang}
          onChange={(e: any) => setDataHarsatBarang(e.target.value)}
          error={error?.harsat}
        />

        <TextInputComponent
          disabled={false}
          label='Nilai'
          value={dataNilaiBarang}
          onChange={(e: any) => setDataNilaiBarang(e.target.value)}
          error={error?.nilai}
        />

        <button className="btn btn-success mt-5" type='submit'>Submit</button>
      </form>
    </div>
  )
}

export default CreateDataComponent