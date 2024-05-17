import React, { FC } from 'react'
type Props={
  label:string;
  create:string;
  }

const HeaderContentHome:FC<Props> = (props)=> {
  return (
    <div className='flex flex-row gap-3  pt-4 ml-[20px] '>
      <div className='flex flex-row justify-between items-center w-full'>
        <div>
          <p className='text-2xl'>{props.label}</p>
          <p className='text-[12px] text-[#8E9BAE]'>Based on yoru preferences</p>
        </div>
        {
          props.create === 'no' ? (
            ""
          ) : (
            <button className="btn btn-sm btn-success mr-10 text-white">Create</button>
          )
        }
      </div>
    </div>
  )
}

export default HeaderContentHome