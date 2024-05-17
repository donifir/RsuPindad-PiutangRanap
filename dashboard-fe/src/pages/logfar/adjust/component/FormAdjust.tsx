import axios from 'axios';
import React, { useRef, useState } from 'react'
import { useRouter } from 'next/router';

import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { header } from '@/pages/_app';
const notify = () => toast.success("upload berhasil silakan reload page!");


const FormAdjust = ({ count, setCount }:{count:any,setCount:any}) => {

  const inputRef = useRef(null)
  const [file, setFile] = useState<any>();
  const [namaBulan, setNamaBulan] = useState<string>('');
  const [loading, setLoading] = useState<boolean>(false);

  const router = useRouter();

  // proses gambar
  const handleChangeFile = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files) {
      var file = e.target.files[0];
      
      setFile(file);
    } else {
      setFile(null)
    }
  };

  const onSubmits = (e: any) => {
    e.preventDefault();
    setLoading(true)
    console.log('data')

    const formData = new FormData()
    formData.append('nama_bulan', namaBulan)
    formData.append('file', file)

    axios.post('/import-excel', formData, header)
    .then(function (response) {
      console.log(response,'sukses');
      setLoading(false)
      notify()
      setCount(count+1)
      setFile('')
      setNamaBulan('')
      // router.reload();
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  

  return (
    <div>
      <form onSubmit={onSubmits} >
        <div className="flex flex-row mr-10 gap-2">
          <div className="customDatePickerWidth">
            <input
              type="text"
              placeholder="Masukan Nama Bulan"
              className="input input-bordered w-full max-w-xs"
              value={namaBulan}
              onChange={(e: any) => setNamaBulan(e.target.value)}
            />
          </div>
          <div className="customDatePickerWidth">
            <input
              type="file"
              id="myFile"
              className="file-input file-input-bordered w-full"
              // value={gambar}
              ref={inputRef}
              onChange={handleChangeFile}
            />
          </div>
          <button className="btn btn-success mr-5" type={loading ? 'button' : 'submit'}>{loading ? "Loading" : 'Submit'}</button>
        </div>
      </form>
    </div>
  )
}

export default FormAdjust