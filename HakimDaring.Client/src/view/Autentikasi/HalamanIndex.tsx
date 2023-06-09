import { useEffect, useState } from 'react'
import { Button, Container, Row, Col } from 'react-bootstrap'
import { useNavigate } from 'react-router-dom';
import TidakMemilikiHak from '../../core/Responses/ResponseGagal/TidakMemilikiHak';
import KesalahanInternalServer from '../../core/Responses/ResponseGagal/KesalahanInternalServer';
import CekMemilikiTokenAutentikasi from '../../core/Autentikasi/CekMemilikiTokenAutentikasi';
import RequestPengecekAutentikasi from '../../core/Autentikasi/RequestPengecekAutentikasi';
import RequestKeluar from '../../core/Autentikasi/RequestKeluar';
import BerhasilMasuk from '../../core/Responses/ResponseBerhasil/Autentikasi/BerhasilMasuk';

function HalamanIndex() {

  const navigate = useNavigate()
  let [hasilCekAutentikasi, setHasilCekAutentikasi] = useState<any>(null)

  const requestPengecekAutentikasi : RequestPengecekAutentikasi = new RequestPengecekAutentikasi (
    new CekMemilikiTokenAutentikasi()
  )
  const requestKeluar : RequestKeluar = new RequestKeluar()
  
  const pindahHalamanMasuk = () => {
    navigate("/masuk")
  }

  const pindahHalamanDaftar = () => {
    navigate("/daftar")
  }

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const kirimPermintaanKeluar = () => {
    requestKeluar.execute(() => {
      setHasilCekAutentikasi(new TidakMemilikiHak())
    })
  }

  useEffect(() => {
    const menanganiHasilAutentikasi = (hasil : any) => {
      setHasilCekAutentikasi(hasil)
    }

    requestPengecekAutentikasi.execute(menanganiHasilAutentikasi)
  }, []) 

  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Col className='h-100 d-flex flex-column justify-content-center'>
          <Row className='m-0 p-0'>
            <Col xs={12} className='my-4 p-2'>
              <p className='text-center fs-1 fw-bold mb-3'>
                Hakim Daring
              </p>
              <Col xs={12} className='d-flex flex-row justify-content-center m-0 p-0 mb-3'>
                <Col xs={8} sm={8} md={4} lg={4} xl={4}>
                  <p className='fs-6'>
                    Hakim Daring adalah situs <s>konsultasi hukum</s> <i className='fst-italic'>online judge</i> yaitu
                    sebuah <i>platform</i> daring untuk menguji kemampuan penyelesaian masalahan dan algoritma
                    seorang <i>programmer</i>.
                  </p>
                </Col>
              </Col>
              <Col xs={12} className='d-flex flex-row justify-content-center m-0 p-0'>
                <Col xs={8} sm={6} md={4} lg={3} xl={2} className='m-0 p-0 d-flex flex-row justify-content-center'>
                  {hasilCekAutentikasi == null && <p className='fs-6'>Menunggu respon dari server...</p>}
                  {hasilCekAutentikasi instanceof KesalahanInternalServer && <p className='fs-6'>Kesalahan internal server, mohon tunggu sebentar. Silahkan refresh halaman untuk mencoba ulang</p>}
                  {(hasilCekAutentikasi instanceof TidakMemilikiHak || hasilCekAutentikasi instanceof BerhasilMasuk) &&
                    <>
                      <Col xs={6} className='m-0 p-0 text-center'>
                        {hasilCekAutentikasi instanceof TidakMemilikiHak && <Button variant='light' className='px-3 border border-dark rounded-pill fs-6' onClick={pindahHalamanMasuk}>Masuk</Button>}
                        {hasilCekAutentikasi instanceof BerhasilMasuk && <Button variant='light' className='px-3 border border-dark rounded-pill fs-6' onClick={kirimPermintaanKeluar}>Keluar</Button>}
                      </Col>
                      <Col xs={6} className='m-0 p-0 text-center'>
                        {hasilCekAutentikasi instanceof TidakMemilikiHak && <Button variant='dark' className='px-3 rounded-pill fs-6' onClick={pindahHalamanDaftar}>Daftar</Button>}
                        {hasilCekAutentikasi instanceof BerhasilMasuk && <Button variant='dark' className='px-3 rounded-pill fs-6' onClick={pindahHalamanJelajah}>Jelajah</Button>}
                      </Col>
                    </>
                  }    
                </Col>
              </Col>
            </Col>
            <Col xs={12} className='my-4 p-2'>
              <p className='text-center fs-4 fw-bold mb-3'>
                Mulai Menjelajah
              </p>
              <Col xs={12} className='d-flex flex-row justify-content-center m-0 p-0 mb-3'>
                <Col xs={8} sm={8} md={4} lg={4} xl={4}>
                  <p className='fs-6'>
                     Anda dapat melihat daftar permasalahan-permasalahan pemrograman pada situs kami tanpa perlu
                     memiliki akun.
                  </p>
                </Col>
              </Col>
              <Col xs={12} className='d-flex flex-row justify-content-center m-0 p-0'>
              <Button variant='light' className=' px-3 border border-dark rounded-pill fs-6' onClick={pindahHalamanJelajah}>Jelajah</Button>
              </Col>
            </Col>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanIndex
