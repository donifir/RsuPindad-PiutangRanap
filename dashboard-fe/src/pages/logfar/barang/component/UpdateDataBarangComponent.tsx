import TextInputComponent from '@/components/input/TextInputComponent'
import { header } from '@/pages/_app';
import axios from 'axios'
import { useRouter } from 'next/router';
import React, { FC, useEffect, useState } from 'react'

import { toast } from 'react-toastify';
const notify = () => toast.success("data berhasil diupdate!");


type Props = {
  id: any;
}

const UpdateDataBarangComponent: FC<Props> = (props) => {
  const [dataKodeBarang, setDataKodeBarang] = useState('')
  const [dataNamaBarang, setDataNamaBarang] = useState('')
  const [dataQtyBarang, setDataQtyBarang] = useState('')
  const [dataHarsatBarang, setDataHarsatBarang] = useState('')
  const [dataNilaiBarang, setDataNilaiBarang] = useState('')
  const [error, setError] = useState<any>([])
  const router = useRouter();

  // getData
  async function getData() {
    try {
      const response = await axios.get(`/data-adjust/barang/${props.id}`);
      setDataKodeBarang(response.data.data.kode_brng)
      setDataNamaBarang(response.data.data.nama_item)
      setDataQtyBarang(response.data.data.qty)
      setDataHarsatBarang(response.data.data.harsat)
      setDataNilaiBarang(response.data.data.nilai)
      console.log(response);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    if (props.id) {
      getData()
    }
  }, [String(props.id)])

  // sendData
  const onSubmits = (e: any) => {
    e.preventDefault();
    e.preventDefault();

    const formData = new FormData()
    formData.append('qty',dataQtyBarang)
    formData.append('harsat',dataHarsatBarang)
    formData.append('nilai',dataNilaiBarang)

    axios.post(`/data-adjust/barang/update/${props.id}`, formData, header)
    .then(function (response) {
      console.log(response);
      router.push(`/logfar/adjust`)
      notify()
    })
    .catch(function (error) {
      setError(error.response.data.message);
      console.log(error.response.data.message);
    });
  }

  return (
    <div>
      <form onSubmit={onSubmits}>
        <TextInputComponent
          disabled={true}
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
        />

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

        <button className="btn btn-success mt-5" type='submit'>Success</button>
      </form>
    </div>
  )
}

export default UpdateDataBarangComponent