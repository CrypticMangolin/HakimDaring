import { Route, Routes } from 'react-router-dom'
import HalamanIndex from './view/HalamanIndex'
import HalamanMasuk from './view/HalamanMasuk'
import HalamanDaftar from './view/HalamanDaftar'
import HalamanBuatSoal from './view/HalamanBuatSoal'
import HalamanUbahSoal from './view/HalamanUbahSoal'
import HalamanJelajah from './view/HalamanJelajah'
import HalamanPengerjaan from './view/HalamanPengerjaan'
import HalamanDiskusi from './view/HalamanDiskusi'


function App() {

  return (
    <>
      <Routes>
        <Route path='/' element={<HalamanIndex />}></Route>
        <Route path='/masuk' element={<HalamanMasuk />}></Route>
        <Route path='/daftar' element={<HalamanDaftar />}></Route>
        <Route path='/buat-soal' element={<HalamanBuatSoal />}></Route>
        <Route path='/edit-soal/:id_soal' element={<HalamanUbahSoal />}></Route>
        <Route path='/jelajah' element={<HalamanJelajah />}></Route>
        <Route path='/soal/:id_soal/pengerjaan' element={<HalamanPengerjaan />}></Route>
        <Route path='/soal/:id_soal/diskusi' element={<HalamanDiskusi />}></Route>
      </Routes>
    </>
  )
}

export default App
