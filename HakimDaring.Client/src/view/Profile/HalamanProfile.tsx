import { useEffect, useState } from 'react'
import { Container, Row, Col } from 'react-bootstrap'
// import { useNavigate } from 'react-router-dom';
import Header from '../Header';
import RequestInformasiUser from '../../core/Profile/RequestInformasiUser';
import InformasiUser from '../../core/Profile/Data/InformasiUser';

function HalamanProfile() {
  // const navigate = useNavigate()
  const [informasiUser, setInformasiUser] = useState<InformasiUser>({nama: '', email: '', tgl_bergabung: '', role: ''});
  
  const requestInformasiUser = new RequestInformasiUser();

  useEffect(() => {
    requestInformasiUser.execute((hasil : any) => {
      setInformasiUser(hasil)
    }) 
  }, []) 

  return (
    <>
      <Header />
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Col className='h-100 d-flex flex-column'>
          <Row className='m-3 p-3'>
            <Col xs={12} className='my-4 p-2'>
              <h2 className="mb-4">Informasi User</h2>
              <Row className='m-0 p-0'>
                <Col xs={12} className='mb-3 col-md-6'>
                <h4>Nama</h4>
                  <p className='fs-6'>
                    {informasiUser.nama}
                  </p>
                </Col>
                <Col xs={12} className='mb-3 col-md-6'>
                  <h4>Role</h4>
                  <p className='fs-6'>
                    {informasiUser.role}
                  </p>
                </Col>
              </Row>
              <Row className='m-0 p-0'>
                <Col xs={12} className='mb-3 col-md-6'>
                <h4>Email</h4>
                  <p className='fs-6'>
                    {informasiUser.email}
                  </p>
                </Col>
                <Col xs={12} className='mb-3 col-md-6'>
                  <h4>Tanggal Bergabung</h4>
                  <p className='fs-6'>
                    {informasiUser.tgl_bergabung}
                  </p>
                </Col>
              </Row>
            </Col>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanProfile
