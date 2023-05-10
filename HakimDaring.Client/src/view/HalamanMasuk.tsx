import { useState } from 'react'
import { Container, Col, Row, Form, FormGroup, Button } from 'react-bootstrap'
import ModelAkunLogin from '../model/ModelAkunLogin'
import InterfaceMasuk from '../core/Interface/InterfaceMasuk'
import Masuk from '../core/Masuk'
import AkunLogin from '../core/Data/AkunLogin'
import BerhasilMasuk from '../core/Data/ResponseBerhasil/BerhasilMasuk'

function HalamanMasuk() {

  const [dataAkun, setDataAkun] = useState<ModelAkunLogin>({
    email : "",
    password : ""
  })

  const [masuk, ] = useState<InterfaceMasuk>(new Masuk())

  const penangananMasuk = (hasil : any) => {
    if (hasil instanceof BerhasilMasuk) {
      alert("Berhasil Masuk")
    }
  }

  const submitMasuk = (e : React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    masuk.masuk(new AkunLogin(dataAkun.email, dataAkun.password), penangananMasuk)
  }

  
  return (
    <>
      <Container className='min-vh-100 min-vw-100 m-0 p-0 d-flex flex-column'>
        <p className='text-center fs-5 m-0 mt-4'>Hakim Daring</p>
        <Col className='h-100 d-flex flex-column justify-content-center'>
          <Row className='m-0 pb-5 p-0'>
            <Col xs={12} className='d-flex flex-row justify-content-center'>
              <Col xs={8} sm={8} md={6} lg={4} xl={3} className=''>
                <Row className='m-0 p-2'>
                  <p className='text-center fs-2 fw-bold m-0'>Masuk</p>
                  <Form onSubmit={submitMasuk}>
                    <FormGroup className='py-2'>
                      <Form.Label>Email</Form.Label>
                      <Form.Control type='email' placeholder='Masukkan email anda' onChange={(e) => setDataAkun({...dataAkun, email : e.target.value})} />
                    </FormGroup>
                    <FormGroup className='py-2'>
                      <Form.Label>Password</Form.Label>
                      <Form.Control type='password' placeholder='Masukkan password anda' onChange={(e) => setDataAkun({...dataAkun, password : e.target.value})} />
                    </FormGroup>
                    <Col className='d-flex flex-row justify-content-center pt-4 pb-5'>
                      <Button variant='dark' type='submit' className='px-4 rounded-pill fs-5'>Masuk</Button>
                    </Col>
                  </Form>
                </Row>
              </Col>
            </Col>
          </Row>
        </Col>
      </Container>
    </>
  )
}

export default HalamanMasuk