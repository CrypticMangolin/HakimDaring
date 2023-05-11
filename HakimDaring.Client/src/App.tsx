import { Route, Routes } from 'react-router-dom'
import HalamanIndex from './view/HalamanIndex'
import HalamanMasuk from './view/HalamanMasuk'
import HalamanDaftar from './view/HalamanDaftar'
import HalamanBuatSoal from './view/HalamanBuatSoal'


function App() {

  return (
    <>
      <Routes>
        <Route path='/' element={<HalamanIndex />}></Route>
        <Route path='/masuk' element={<HalamanMasuk />}></Route>
        <Route path='/daftar' element={<HalamanDaftar />}></Route>
        <Route path='/buat-soal' element={<HalamanBuatSoal />}></Route>
      </Routes>
    </>
  )
}

export default App
