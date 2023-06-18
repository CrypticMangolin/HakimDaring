import { useState, useEffect } from 'react'
import {Button, Col, Container, Row} from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import Header from '../Header'
import BerhasilAmbilHasilPengerjaan from '../../core/Responses/ResponseBerhasil/Pengerjaan/BerhasilAmbilHasilPengerjaan'
import RequestAmbilHasilPengerjaan from '../../core/Pengerjaan/RequestAmbilHasilPengerjaan'

import AceEditor from 'react-ace'

import "ace-builds/src-noconflict/theme-iplastic"
import "ace-builds/src-noconflict/ext-language_tools"
import BahasaPemrograman from '../../core/Pengerjaan/Data/BahasaPemrograman'
import DaftarBahasa from '../../core/Pengerjaan/DaftarBahasa'
import ResponseHasilPengerjaanTestcase from '../../core/Responses/ResponseBerhasil/Pengerjaan/ResponseHasilPengerjaanTestcase'

function HalamanHasilPengerjaan() {

  let navigate = useNavigate()
  const parameterURL = useParams()

  const requestAmbilHasilPengerjaan : RequestAmbilHasilPengerjaan = new RequestAmbilHasilPengerjaan()
  const daftarBahasa : DaftarBahasa = new DaftarBahasa()

  let [hasilPengerjaan, setHasilPengerjaan] = useState<BerhasilAmbilHasilPengerjaan|null>(null)
  let [daftarModeBahasa, ] = useState<BahasaPemrograman[]>(daftarBahasa.ambilBahasa())

  const pindahHalamanJelajah = () => {
    navigate("/")
  }

  const pindahHalamanPengerjaan = () => {
    if (hasilPengerjaan != null) {
      navigate(`/soal/${hasilPengerjaan.id_soal}/pengerjaan`)
    }
  }

  const pindahHalamanDiskusi = () => {
    if (hasilPengerjaan != null) {
      navigate(`/soal/${hasilPengerjaan.id_soal}/diskusi`)
    }
  }

  const pindahHalamanHasil = () => {
    if (hasilPengerjaan != null) {
      navigate(`/soal/${hasilPengerjaan.id_soal}/hasil`)
    }
  }

  useEffect(() => {
    if (parameterURL.id_pengerjaan === undefined) {
      pindahHalamanJelajah()
    }
    requestAmbilHasilPengerjaan.execute(parameterURL.id_pengerjaan!, (hasil : any) => {

      if (hasil instanceof BerhasilAmbilHasilPengerjaan) {
        setHasilPengerjaan(hasil)
      }
      else {
        window.location.reload()
      }
    })
  }, [])

  return (
    <>
      <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
        <Header />
        <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanPengerjaan}>
            <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
              Pengerjaan
            </Button>
          </Col>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanDiskusi}>
            <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
              Diskusi
            </Button>
          </Col>
          <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanHasil}>
            <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
              Submission
            </Button>
          </Col>
          <hr className='m-0 p-0'></hr>
        </Row>
        <Col xs={12} className='m-0 p-0 d-flex justify-content-center'>
          <Col xs={12} sm={12} md={8} lg={6} xl={6} className='m-0 p-0'>
            <Row className='m-0 p-0 d-flex flex-column'>
              <p className='m-0 py-1 fs-5 fw-bold text-center'>Hasil Pengerjaan</p>
              {hasilPengerjaan != null &&
                <Row className='m-0 p-0 d-flex flex-column'>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Nama user:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.nama_user}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Soal:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.judul_soal}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Hasil:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.hasil + (hasilPengerjaan.outdated ? "[outdated]" : "")}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Total waktu:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.total_waktu}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Total memori:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.total_memori}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Tanggal submit:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.tanggal_submit}</p>
                      </Col>
                    </Row>
                  </Col>
                  <Col xs={12} className='m-0 p-0'>
                    <Row className='m-0 p-0 d-flex flex-row'>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-end'>Bahasa:</p>
                      </Col>
                      <Col xs={6} className='m-0 p-0'>
                        <p className='m-0 px-2 py-1 fs-6 text-start'>{hasilPengerjaan.bahasa}</p>
                      </Col>
                    </Row>
                  </Col>
                  {hasilPengerjaan.source_code != null &&
                    <Col xs={12} className='m-0 py-2'>
                      <AceEditor
                        placeholder="Placeholder Text"
                        mode={hasilPengerjaan ? daftarModeBahasa.find(e => e.bahasa == hasilPengerjaan?.bahasa)?.mode : "" }
                        theme="iplastic"
                        fontSize={14}
                        showPrintMargin={true}
                        showGutter={true}
                        highlightActiveLine={true}
                        width='100'
                        height='480px'
                        value={hasilPengerjaan.source_code ? hasilPengerjaan.source_code : undefined}
                        readOnly={true}
                        setOptions={{
                          enableBasicAutocompletion: true,
                          enableLiveAutocompletion: true,
                          enableSnippets: false,
                          showLineNumbers: true,
                          tabSize: 4,
                        }}
                      />
                    </Col>
                  }
                  <Col xs={12} className='m-0 py-2'>
                    <p className='m-0 p-0 px-2 fs-6 fw-bold text-center'>Hasil Testcase</p>
                    <Row className='m-0 p-0 d-flex flex-column'>
                      {
                        hasilPengerjaan.hasil_testcase.map((value : ResponseHasilPengerjaanTestcase) => (
                          <Row className='m-0 p-0 d-flex flex-column py-1 border border-dark'>
                            <Col xs={12} className='m-0 p-0 py-1'>
                              <Row className='m-0 p-0 d-flex flex-row'>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-end'>Status:</p>
                                </Col>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-start'>{value.status}</p>
                                </Col>
                              </Row>
                            </Col>
                            <Col xs={12} className='m-0 p-0 py-1'>
                              <Row className='m-0 p-0 d-flex flex-row'>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-end'>Waktu:</p>
                                </Col>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-start'>{value.waktu}</p>
                                </Col>
                              </Row>
                            </Col>
                            <Col xs={12} className='m-0 p-0 py-1'>
                              <Row className='m-0 p-0 d-flex flex-row'>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-end'>Memori:</p>
                                </Col>
                                <Col xs={6} className='m-0 p-0'>
                                  <p className='m-0 p-0 px-2 fs-6 text-start'>{value.memori}</p>
                                </Col>
                              </Row>
                            </Col>
                          </Row>
                        ))
                      }
                    </Row>
                  </Col>
                </Row>
              }
            </Row>
          </Col>
        </Col>
      </Container>
    </>
  )
}

export default HalamanHasilPengerjaan