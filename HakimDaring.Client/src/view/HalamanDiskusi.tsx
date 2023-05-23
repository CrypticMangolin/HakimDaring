import { useState, useEffect } from 'react'
import { Container, Col, Row, Button } from 'react-bootstrap'
import Header from './Header'
import { useNavigate, useParams } from 'react-router-dom'
import AmbilIDRuanganDiskusiSoal from '../core/Soal/AmbilIDRuanganDiskusiSoal'
import InterfaceAmbilIDRuanganDikusiSoal from '../core/Soal/Interface/InterfaceAmbilIDRuanganDikusiSoal'
import IDSoal from '../core/Data/IDSoal'
import IDRuangan from '../core/Data/IDRuanganComment'
import InterfaceDaftarComment from '../core/Comment/Interface/InterfaceDaftarComment'
import DaftarComment from '../core/Comment/DaftarComment'
import Comment from '../core/Data/Comment'
import InterfaceKirimComment from '../core/Comment/Interface/InterfaceKirimComment'
import KirimComment from '../core/Comment/KirimComment'
import IDComment from '../core/Data/IDComment'
import BerhasilMengirimComment from '../core/Data/ResponseBerhasil/BerhasilMengirimComment'

function HalamanDiskusi() {

  const navigate = useNavigate()
  const parameterURL = useParams()

  const pindahHalamanPengerjaan = () => {
    navigate(`/soal/${parameterURL.id_soal}/pengerjaan`)
  }

  const [daftarKomentar, setDaftarKomentar] = useState<Comment[]>([])
  const [komentar, setKomentar] = useState<string>("")
  const [reply, setReply] = useState<IDComment|null>(null)

  const ambilIDRuanganDiskusi : InterfaceAmbilIDRuanganDikusiSoal = new AmbilIDRuanganDiskusiSoal()
  const ambilDaftarComment : InterfaceDaftarComment = new DaftarComment()
  const kirimComment : InterfaceKirimComment = new KirimComment()
  
  let [idRuanganDiskusi, setIDRuanganDiskusi] = useState<null|IDRuangan>(null)

  useEffect(() => {
    if (parameterURL.id_soal != null && !Number.isNaN(Number(parameterURL.id_soal))) {
      ambilIDRuanganDiskusi.ambilIDRuangan(new IDSoal(Number(parameterURL.id_soal)), (hasil : any) => {
        if (hasil instanceof IDRuangan) {
          setIDRuanganDiskusi(hasil)
        }
        else {
          pindahHalamanPengerjaan()
        }
      })
    }
    else {
      pindahHalamanPengerjaan()
    }

    function loadScriptCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor") == null) {
          const script = document.createElement('script');
          script.src = "/ckeditor5-38.0.1/build/ckeditor.js";
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
        }
      });
    }
    function loadScriptCustomCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor-custom-build") == null) {
          const script = document.createElement('script');
          script.innerHTML = `
            let ckEditor = null
            
            ClassicEditor.create( '', {
                licenseKey: '',
            })
            .then( editor => {
                window.editor_comment = editor;
                editor.model.document.on('change:data', () => {
                  window.perubahanCKEditor(editor.getData())
                })
                document.getElementById("editor").appendChild(editor.ui.element)
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: n96xuuc5ag4v-nk96buq2xi5g' );
                console.error( error );
            })`;
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor-custom-build"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
          document.getElementById("editor")?.appendChild((window as any).editor_comment.ui.element)
        }
      });
    }

    async function loadCKEditor() {
      await loadScriptCKEditor()
      await loadScriptCustomCKEditor()

      document.getElementById("editor")?.append((window as any).editor_comment.ui.element)
    }

    return () => {
      loadCKEditor()
    };

  }, [])

  const submitComment = () => {
    if (idRuanganDiskusi != null) {
      kirimComment.kirimComment(idRuanganDiskusi, komentar, reply, (hasil : any) => {
        if (hasil instanceof BerhasilMengirimComment) {
          (window as any).editor_comment.setData("")
        }
      })
    }
    else {
      pindahHalamanPengerjaan()
    }
  }

  useEffect(() => {
    if (idRuanganDiskusi != null) {
      ambilDaftarComment.ambilDaftarComment(idRuanganDiskusi, (hasil : any) => {
        if (Array.isArray(hasil)) {
          let daftarComment : Comment[] = hasil as Comment[]
          setDaftarKomentar(daftarComment)
        }
      })
    }
  }, [idRuanganDiskusi])

  
  function perubahanCKEditor(komentar : string) {
    setKomentar(komentar)
  }
  (window as any).perubahanCKEditor = perubahanCKEditor

  return (
  <>
    <Container className='min-vh-100 min-vw-100 m-0 p-0 d-flex flex-column'>
      <Header />
      <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
            Pengerjaan
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='dark' className='m-0 w-100 rounded-0 text-center'>
            Diskusi
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
            Submission
          </Button>
        </Col>
        <hr className='m-0 p-0'></hr>
      </Row>
      <Col xs={12} className='m-0 p-0 d-flex justify-content-center'>
        <Col xs={12} sm={12} md={8} lg={6} xl={6} className='m-0 p-0'>
          <Row className="m-0 p-0 d-flex flex-column">
            <Row className="m-0 p-0 d-flex flex-column">
              {daftarKomentar.map((komen : Comment, index : number) => {

                let balasan : number = -1
                if (komen.reply != null) {
                  balasan = daftarKomentar.findIndex((c) => c.id.id === komen.reply!.id)
                }

                return (
                  <section id={`k-${index}`} className='m-0 pb-3' key={komen.id.id}>
                    <Row className='m-0 py-1 d-flex flex-column'>
                      <p className="m-0 py-1 fs-6 text-start border border-dark">{komen.namaPenulis}</p>
                      {
                        balasan != -1 &&
                        <a className='m-0 py-1 fs-6 text-dark bg-secondary text-decoration-none border border-dark' href={`#k-${balasan}`}>
                          <blockquote className='m-0 py-1 blockquote fs-6 text-truncate'>
                            <p className='text-truncate' dangerouslySetInnerHTML={{ __html: daftarKomentar[balasan].pesan}}>
                            </p>
                          </blockquote>
                        </a>
                      }
                      <Col xs={12} dangerouslySetInnerHTML={{ __html: komen.pesan}} className='border border-dark'></Col>
                      <a href='#kolom-komentar' onClick={() => {
                        setReply(komen.id)
                      }}>Balas</a>
                    </Row>
                  </section>
                )
              })}
            </Row>
            <Col className='m-0 my-3 p-0'>
              <section id="kolom-komentar" className='m-0 p-0'>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={9} className='m-0 p-0 px-2'>
                      {
                        reply != null && 
                        <Row className='m-0 p-0 d-flex flex-row'>
                          <Col xs={10} className='m-0 p-0'>
                            <blockquote className='blockquote fs-6'>
                              <p className='text-truncate' dangerouslySetInnerHTML={{ __html: daftarKomentar.find((c) => c.id.id === reply.id)!.pesan}}>
                              </p>
                            </blockquote>
                          </Col>
                          <Col xs={2} className='m-0 p-0 d-flex flex-column'>
                            <Button variant='light' className='rounded-0 border border-dark' onClick={() => {
                              setReply(null)
                            }}>
                              X
                            </Button>
                          </Col>
                        </Row>
                      }
                      <div id="editor">
                      </div>
                  </Col>
                  <Col xs={3} className='m-0 p-0 px-2'>
                    <Button variant='dark' className='px-3 rounded-pill' onClick={submitComment}>
                      Kirim
                    </Button>
                  </Col>
                </Row>
              </section>
            </Col>
          </Row>
        </Col>
      </Col>
    </Container>
  </>)
}

export default HalamanDiskusi