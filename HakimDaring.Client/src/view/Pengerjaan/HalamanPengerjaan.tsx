import { useEffect, useState } from 'react'
import { Container, Col, Row, Form, Button } from 'react-bootstrap'
import Header from '../Header'
import { useNavigate, useParams } from 'react-router-dom'
import AceEditor from 'react-ace'

import "ace-builds/src-noconflict/theme-iplastic"
import "ace-builds/src-noconflict/ext-language_tools"
import BerhasilAmbilInformasiSoal from '../../core/Responses/ResponseBerhasil/Soal/BerhasilAmbilInformasiSoal'
import ResponseBatasanSoal from '../../core/Responses/ResponseBerhasil/Soal/ResponseBatasanSoal'
import RequestAmbilInformasiSoal from '../../core/Soal/RequestAmbilInformasiSoal'
import DaftarBahasa from '../../core/Pengerjaan/DaftarBahasa'
import RequestUjiCobaProgram from '../../core/Pengerjaan/RequestUjiCobaProgram'
import RequestTestcase from '../../core/Testcase/RequestTestcase'
import CekMemilikiTokenAutentikasi from '../../core/Autentikasi/CekMemilikiTokenAutentikasi'
import RequestSubmitPengerjaan from '../../core/Pengerjaan/RequestSubmitPengerjaan'
import BahasaPemrograman from '../../core/Pengerjaan/Data/BahasaPemrograman'
import BerhasilUjiCobaProgram from '../../core/Responses/ResponseBerhasil/Pengerjaan/BerhasilUjiCobaProgram'
import SubmitPengerjaan from '../../core/Pengerjaan/Data/SubmitPengerjaan'
import BerhasilSubmitPengerjaan from '../../core/Responses/ResponseBerhasil/Pengerjaan/BerhasilSubmitPengerjaan'
import ResponseTestcase from '../../core/Responses/ResponseBerhasil/Soal/ResponseTestcase'
import UjiCoba from '../../core/Pengerjaan/Data/UjiCoba'
import RequestGantiSoal from '../../core/Soal/RequestGantiSoal'
import GantiStatus from '../../core/Soal/Data/GantiStatus'
import BerhasilGantiSoal from '../../core/Responses/ResponseBerhasil/Soal/BerhasilGantiSoal'


function HalamanPengerjaan() {

  const navigate = useNavigate()
  const parameterURL = useParams()
  let [informasiSoal, setInformasiSoal] = useState<BerhasilAmbilInformasiSoal>({
    id_soal : "",
    judul : "",
    isi_soal : "",
    id_pembuat : "",
    nama_pembuat : "",
    batasan : {
      waktu_per_testcase : 0,
      waktu_total : 0,
      memori : 0
    } as ResponseBatasanSoal,
    jumlah_berhasil : 0,
    jumlah_submit : 0,
    status : "",
    id_ruangan_diskusi : ""
  })

  const pindahHalamanJelajah = () => {
    navigate("/jelajah")
  }

  const pindahHalamanDiskusi = () => {
    navigate(`/soal/${parameterURL.id_soal}/diskusi`)
  }

  const pindahHalamanHasil = () => {
    navigate(`/soal/${parameterURL.id_soal}/hasil`)
  }

  const pindahHalamanMasuk = () => {
    navigate("/masuk")
  }

  const requestAmbilInformasiSoal : RequestAmbilInformasiSoal = new RequestAmbilInformasiSoal()
  const daftarBahasa : DaftarBahasa = new DaftarBahasa()
  const requestUjiCobaProgram : RequestUjiCobaProgram = new RequestUjiCobaProgram()
  const requestTestcase : RequestTestcase = new RequestTestcase()
  const cekAutentikasi : CekMemilikiTokenAutentikasi = new CekMemilikiTokenAutentikasi()
  const requestSubmitPengerjaan : RequestSubmitPengerjaan = new RequestSubmitPengerjaan()
  const requestGantiSoal : RequestGantiSoal = new RequestGantiSoal()

  let [daftarModeBahasa, ] = useState<BahasaPemrograman[]>(daftarBahasa.ambilBahasa())
  let [bahasaDipilih, setBahasaDipilih] = useState<number>(0)

  let [ujiCoba, setUjiCoba] = useState<string[]>([])

  let [submitPengerjaan, setSubmitPengerjaan] = useState<SubmitPengerjaan>({
    id_soal : "",
    source_code : "",
    bahasa : ""
  })

  let [hasilUjiCoba, setHasilUjiCoba] = useState<(BerhasilUjiCobaProgram|null)[]>([])
  let [daftarContohInput, setDaftarContohInput] = useState<ResponseTestcase[]>([])
  let [telahLogin, setTelahLogin] =  useState<boolean>(false)


  const pilihBahasa = (e : any) => {
    setBahasaDipilih(e.target.value)
  }

  const perubahanSourceCode = (code : string) => {
    setSubmitPengerjaan({...submitPengerjaan, source_code : code})
  }

  const tambahCustomInput = () => {
    if (ujiCoba.length < 6) {
      setUjiCoba([...ujiCoba, ""])
      setHasilUjiCoba([...hasilUjiCoba, null])
    }
  }

  const hapusCostumInput = (index : number) => {
    let inputCustomBaru = [...ujiCoba]
    inputCustomBaru.splice(index, 1)
    setUjiCoba(inputCustomBaru)

    let hasilUjiCobaBaru = [...hasilUjiCoba]
    hasilUjiCobaBaru.splice(index, 1)
    setHasilUjiCoba(hasilUjiCobaBaru)
  }

  const gantiCostumInput = (index : number, input : string) => {
    let inputCustomBaru = [...ujiCoba]
    inputCustomBaru[index] = input
    setUjiCoba(inputCustomBaru)
  }

  const runUjiCobaProgram = () => {
    if (informasiSoal.id_soal != "") {

      requestUjiCobaProgram.execute({
        id_soal : informasiSoal.id_soal,
        bahasa : submitPengerjaan.bahasa,
        source_code : submitPengerjaan.source_code,
        stdin : ujiCoba
      } as UjiCoba, (hasil : any) => {
        if (Array.isArray(hasil)) {
          setHasilUjiCoba(hasil)
        }
      })
    }
  }

  const submit = () => {
    requestSubmitPengerjaan.execute(submitPengerjaan, (hasil : any) => {
      if (hasil instanceof BerhasilSubmitPengerjaan) {
        navigate(`/pengerjaan/${hasil.id_pengerjaan}`);
      }
    })
  }

  const StatusChange = () => {
    let nextState: string
    if (informasiSoal.status == 'publik') {
      nextState = 'suspend'
    } else {
      nextState = 'publik'
    }
    requestGantiSoal.execute({id_soal : informasiSoal.id_soal, status : nextState} as GantiStatus,  (hasil : any) => {
      if (hasil instanceof BerhasilGantiSoal) {
        setInformasiSoal(prevState => ({
          ...prevState,
          status: nextState
        }))
      }
    })
  };
  
  useEffect(() => {
    setTelahLogin(cekAutentikasi.cekApakahMemilikiTokenAutentikasi())
    setSubmitPengerjaan({...submitPengerjaan, bahasa : daftarModeBahasa[bahasaDipilih].bahasa})

    if (parameterURL.id_soal === undefined) {
      pindahHalamanJelajah()
    }
    requestAmbilInformasiSoal.execute(parameterURL.id_soal!, (hasil : any) => {
      if (hasil instanceof BerhasilAmbilInformasiSoal) {
        setInformasiSoal(hasil)
      }
      else {
        pindahHalamanJelajah()
      }
    })

    requestTestcase.execute(parameterURL.id_soal!, (hasil : any) => {
      if (Array.isArray(hasil)) {
        setDaftarContohInput(hasil)
      }
    })
  }, [])

  useEffect(() => {
    setSubmitPengerjaan({...submitPengerjaan, id_soal : informasiSoal.id_soal})
  }, [informasiSoal])

  useEffect(() => {
    setSubmitPengerjaan({...submitPengerjaan, bahasa : daftarModeBahasa[bahasaDipilih].bahasa})
  }, [bahasaDipilih])

  return (
  <>
    <Container className='min-vh-100 mw-100 m-0 p-0 d-flex flex-column'>
      <Header />
      <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='dark' className='m-0 w-100 rounded-0 text-center'>
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
      <Row className='m-0 p-0'>
        <Col sm={12} md={12} lg={6} xl={6} className="d-flex flex-column m-0 p-2">
          <Row className='m-0 p-0 px-4 d-flex flex-column'>
            <Col className='m-0 p-0'>
              <Row className='m-0 mb-4 px-5 p-0 d-flex flex-column'>
                <p className='m-0 py-2 fs-4 fw-bold text-center'>{informasiSoal.judul}</p>
              </Row>
            </Col>
            <Col className='m-0 mb-2 p-0'>
              <Col className='m-2 p-0' dangerouslySetInnerHTML={{ __html: informasiSoal.isi_soal}}>
              </Col>
            </Col>
            <Col className='m-0 p-0'>
              <Row className='m-0 p-0 d-flex flex-column'>
                <p className="m-0 mb-1 p-0 fs-5 fw-bold">Batasan Soal</p>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Waktu per testcase</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal.batasan.waktu_per_testcase}</b> sekon</p>
                  </Col>
                </Row>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Waktu total</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal.batasan.waktu_total}</b> sekon</p>
                  </Col>
                </Row>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={4} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>Batasan memori</p>
                  </Col>
                  <Col xs={8} className='m-0 p-0'>
                    <p className='m-0 p-0 fs-6'>: <b>{informasiSoal.batasan.memori}</b> KB</p>
                  </Col>
                </Row>
              </Row>
            </Col>
            <Col className='m-0 p-0 py-4'>
              <Row className='m-0 p-0 d-flex flex-column'>
                <p className='m-0 p-0 fs-5 fw-bold text-start'>Contoh Input</p>
                {daftarContohInput.map((value : ResponseTestcase, index : number) => {
                  return (
                    <Row className='m-0 p-0 py-2 d-flex flex-column' key={index}>
                      <p className='m-0 p-0 fs-6'>Input {index + 1}</p>
                      <textarea rows={3} className='m-0 p-0 pb-2' readOnly value={value.testcase} style={{resize: 'none'}}/>
                      <p className='m-0 p-0 fs-6'>Output {index + 1}</p>
                      <textarea rows={3} className='m-0 p-0 pb-2' readOnly value={value.jawaban} style={{resize: 'none'}}/>
                    </Row>
                  )
                })}
              </Row>
            </Col>
          </Row>
        </Col>
        <Col sm={12} md={12} lg={6} xl={6} className="d-flex flex-column m-0 p-2">
          <Row className='m-0 p-0 d-flex gap-2 flex-row'>
            { informasiSoal.status == 'publik' ? (
                'admin' == localStorage.getItem("role") &&
                <Col className="d-flex flex-column m-0 p-0">
                  <Button variant='warning' className='my-2' onClick={StatusChange}>
                    Suspend Soal
                  </Button>
                </Col>
              ) : (
                'admin' == localStorage.getItem("role") &&
                <Col className="d-flex flex-column m-0 p-0">
                  <Button variant='success' className='my-2' onClick={StatusChange}>
                    Publik Soal
                  </Button>
                </Col>
              ) 
            }
            <Col className="d-flex flex-column m-0 p-0">
              {informasiSoal.id_pembuat == localStorage.getItem("id") &&
                <Button variant='dark' className='my-2' onClick={() => {navigate(`/edit-soal/${informasiSoal.id_soal}`)}}>
                  Edit Soal
                </Button>
              }
            </Col>
          </Row>
          <Row className='m-0 p-0 d-flex flex-column'>
            <Row className='m-0 mb-2 p-0 d-flex flex-row'>
              <Col xs={2} className='m-0 p-0'>
                <Form.Select size='sm' value={daftarModeBahasa.length > 0 ? bahasaDipilih : ""} onChange={pilihBahasa}>
                  {daftarModeBahasa.map((value : BahasaPemrograman, index : number) => (
                    <option key={index} value={index}>{value.bahasa}</option>
                  ))}
                </Form.Select>
              </Col>
            </Row>
            <AceEditor
              placeholder="Placeholder Text"
              mode={daftarModeBahasa[bahasaDipilih].mode}
              theme="iplastic"
              fontSize={14}
              showPrintMargin={true}
              showGutter={true}
              highlightActiveLine={true}
              width='100vw'
              value={submitPengerjaan.source_code}
              onChange={perubahanSourceCode}
              setOptions={{
                enableBasicAutocompletion: true,
                enableLiveAutocompletion: true,
                enableSnippets: false,
                showLineNumbers: true,
                tabSize: 4,
              }}/>
            {
              telahLogin &&
              <>
                <p className='m-0 p-0 my-2 text-center fs-5 fw-bold'>Custom Test</p>
                <Row className='m-0 p-0 d-flex flex-column' xs={12}>
                  {ujiCoba.map((value : string, index : number) => (
                    <Row key={index} className='m-0 p-0 d-flex flex-row mb-1' xs={12}>
                      <Col xs={1} className='m-0 p-0 justify-content-center'>
                        <Button variant="light" className="w-100 h-100 m-0 rounded-0 border border-dark" onClick={() => {hapusCostumInput(index)}}>X</Button>
                      </Col>
                      <Col xs={5} className='m-0 p-0'>
                        <textarea className='m-0 w-100 h-100' rows={3} placeholder='Masukkan input' style={{"resize" : "none"}} onChange={(e) => {gantiCostumInput(index, e.target.value)}} value={value}/>
                      </Col>
                      <Col xs={5} className='m-0 p-0'>
                        <textarea className='m-0 w-100 h-100' readOnly rows={3} style={{"resize" : "none"}} value={hasilUjiCoba[index]?.stdout}/>
                      </Col>
                    </Row>
                  ))}
                  <Row className='m-0 p-0 d-flex flex-row'>
                    {
                      ujiCoba.length < 6 && 
                      <Col className='m-0 mb-1 p-0' xs={4}>
                        <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={tambahCustomInput}>Tambah testcase +</Button>
                      </Col>
                    }
                    <Col className='m-0 mb-1 p-0' xs={4}>
                      <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={runUjiCobaProgram}>Run Testcase</Button>
                    </Col>
                    <Col className='m-0 mb-1 p-0' xs={4}>
                      <Button variant='light' className='btn-block m-0 rounded-0 border border-dark' onClick={submit}>Submit</Button>
                    </Col>
                  </Row>
                </Row>
              </>
            }
            {
              !telahLogin &&
              <Col className='m-0 p-0 py-2 d-flex justify-content-center'>
                <Button variant='dark' className='m-0 fs-6' onClick={pindahHalamanMasuk}>
                  Masuk untuk mengerjakan soal
                </Button>
              </Col>
            }
          </Row>
        </Col>
      </Row>
    </Container>
  </>)
}

export default HalamanPengerjaan